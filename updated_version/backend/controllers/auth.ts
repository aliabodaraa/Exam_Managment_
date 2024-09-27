import { Request, Response, NextFunction } from "express";
import { User } from "../models/user";
import CustomError from "../utils/CustomError";
import jwt from 'jsonwebtoken';
import {promisify} from 'util';
type TokenType={id:string,iat:string};

const signToken=async(id:string)=>{
    console.log("process.env.JWT_SECRET_STR",process.env.JWT_SECRET_STR)
    return await jwt.sign({ id }, process.env.JWT_SECRET_STR, {expiresIn:process.env.JWT_LOGIN_EXPIRES})
}

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
        if(!user || !(await user.comparePassworsInDb(password,user.dataValues.password))){
            const err= new CustomError('Incorrect Email Or Password !',400);
            return next(err);
        }
        const token = await signToken(user.dataValues.id)
        res.status(201).json({ message: "User logging", user, token });
        console.log("STORED NEW User");
    } catch (err: any) {
        return next(err);
    }
};

export const protect=async (
    req: any,
    res: Response,
    next: NextFunction
) => {
    const testToken=req.headers.authorization
    //1. read the token and check if it is exist
    let token:string|null=null;
    if(testToken && testToken.startsWith('Bearer')) token = testToken.split(' ')[1];
    if(!token) return next(new CustomError('You Are Not LoggedIn', 401));
    //2. validate the token
    let decodedToken:TokenType|null=null;
    try{
        decodedToken=await promisify(jwt.verify)(token, process.env.JWT_SECRET_STR);
    }catch(e:any){
        return next(new CustomError(`${e.name} ${e.message}`, 401))
    }

    //3. check if the user exist
    const user = await User.scope('withoutPassword').findByPk(decodedToken?.id);
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