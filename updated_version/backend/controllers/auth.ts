import { Request, Response, NextFunction } from "express";
import { User } from "../models/user";
import CustomError from "../utils/CustomError";
import { sendEmail } from "../email";
import { Op } from "sequelize";
import { hashPassword } from "../utils/hash";
import { signToken, verifyToken } from "../utils/jwt";
import jwt, { UserIDJwtPayload } from 'jsonwebtoken';

export const login = async (
    req: Request,
    res: Response,
    next: NextFunction
) => {
    try {
        const email = req.body.email;
        const password = req.body.password;
        if(!email || !password){
            const err= new CustomError('Please provide email ID & Password for login !',400);
            return next(err);
        }
        //check if user exists with given email
        const user = await User.findOne({where:{email}});
        if(!user || !(await user.comparePassworsInDb(password))){
            const err= new CustomError('Incorrect Email Or Password !',400);
            return next(err);
        }
        const token = signToken(user.dataValues.id)
        res.status(201).json({ message: "User logging", user, token });
        console.log("LOGGING User");
    } catch (err: any) {
        return next(err);
    }
};

export const protect=async (
    req: any,
    res: Response,
    next: NextFunction
) => {
    const headerToken=req.headers.authorization
    //1. read the token and check if it is exist
    let token:string|null=null;
    if(headerToken && headerToken.startsWith('Bearer')) token = headerToken.split(' ')[1];
    if(!token) return next(new CustomError('You Are Not LoggedIn', 401));
    //2. validate the token
    let decodedToken:UserIDJwtPayload|null=null;
    try{
        decodedToken = verifyToken(token)
    }catch(e:any){
        return next(new CustomError(`${e.name} ${e.message}`, 401))
    }

    //3. check if the user exist
    const user = await User.scope('withoutPassword').findByPk(decodedToken.id);
    if(!user){
        return next(new CustomError('the user with given token does not exist', 401))
    }

    //4. check if the user change it's password after the token was issued
    if(user.isPasswordsChanged(decodedToken?.iat)){
        const err=new CustomError('the password has been changed recently, please login again', 401);
        return next(err);
    }
    
    //5. allow user to access route
    req.user=user;
    next();
}

export const restrict=(...roles:string[])=>{
    return (
        req: Request,
        res: Response,
        next: NextFunction
    ) => {
        let req_=req as any;
        console.log(req_.user.dataValues.role,req_.user.dataValues.temporary_role,"req_.user.dataValues")
        if(!roles.includes(req_.user.dataValues.role) && !roles.includes(req_.user.dataValues.temporary_role)){
            return next(new CustomError('you do not have a right permission to perform this action',401))
        }
        return next();
    }
}

export const forgotPassword=async(
        req: Request,
        res: Response,
        next: NextFunction) => {
            //1. get user based on posted email
            const email = req.body.email;
            const user = await User.findOne({where:{email}});
            if(!user){
                return next(new CustomError('we could not find the user with given eamil !',400));
            }
            //2. generate a random reset token
            const resetToken=await user.createResetPasswordToken();
            
            //3. send the token back to the user email
            const resetUrl=`${req.protocol}://${req.hostname}/auth/resetPassword/${resetToken}`;
            const message=`we have received a password reset request, please use the below link to reset your password\n\n${resetUrl}\n\n this reset password link will be valid only for 10 minutes.`
            try{
                await sendEmail({
                    email:user.dataValues.email,
                    subject:'password change request received',
                    message
                });
                return res.json({message:'password reset link sent to the user email successfully',token:resetToken})
            }catch(e){
                await user.resetPasswordTokenRejection();
                return next(new CustomError('there was an error swnding password reset email. please try again later', 500))
            }

}

export const resetPassword=async(
    req: Request,
    res: Response,
    next: NextFunction) => {
            //1. get user that his token matches the incoming token
            const token =(await hashPassword(req.params.token)).hash.toString('hex');
            console.log(req.params.token,"----2----",token,"TOOOKEN")
            const user = await User.findOne({where:{passwordResetToken: token, passwordResetTokenExpires: {[Op.gt]: Date.now()}}});
            if(!user) return next(new CustomError('Token is invalid or has expired !',400));

            await user.changePassword(req.body.password, req.body.confirm_password);

            //Login the user
            const loginToken = await signToken(user.dataValues.id)
            res.status(201).json({ message: "reseting password successfully", user, token:loginToken });
}

// sault problem with using crypto
// 4ac77d6d-4715-46ef-9b8f-6c1863761c78     $2b$12$bgwT4yFh0zC72Xc7b7rEIOdszKqeVKwVY1APpj2QAwMWUIVr6XCYe
// 4ac77d6d-4715-46ef-9b8f-6c1863761c78     $2b$12$Kv9.lWqObPzXQUNZ5SIQ7eNr5vYW/RynRu62X27ZVdQ72J6kdtFu2

// 799d997a-410a-4dea-95b9-ab9fe58364ac     $2b$12$.jwvMPxcRrHpH3sUA9go1OIF.yjdBa1rz3w5pi797l/sJVYV0Stbu
// 799d997a-410a-4dea-95b9-ab9fe58364ac     $2b$12$ZQKufzii5buPsa3lbHtyx.URcPzdhQCDs3aGuiLPPrtUenFilXwGe