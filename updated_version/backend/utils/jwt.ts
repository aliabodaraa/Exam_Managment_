declare module 'jsonwebtoken' {
    export interface UserIDJwtPayload extends jwt.JwtPayload {
        id: number
    }
}

import jwt, { Secret, UserIDJwtPayload } from 'jsonwebtoken';
export const signToken=(id:string)=>{
    return jwt.sign({ id }, process.env.JWT_SECRET! as Secret, {expiresIn:process.env.JWT_LOGIN_EXPIRES,algorithm:"HS256",subject:id.toString()})
}
export const verifyToken=(token:string)=>{
    return jwt.verify(token, process.env.JWT_SECRET!  as Secret) as UserIDJwtPayload
}
