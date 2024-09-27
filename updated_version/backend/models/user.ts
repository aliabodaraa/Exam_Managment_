import { DataTypes, Deferrable } from "sequelize";
import sequelize from "../util/database";
import CustomError from "../utils/CustomError";
import { USER_PROPERTIES, USER_ROLES, USER_TEMPORARY_ROLES } from "../util/constansts";
import bcrypt from "bcrypt";

export const User = sequelize.define(
    "user",
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            allowNull: false,
            primaryKey: true
        },
        username: {type:DataTypes.STRING,unique:true,allowNull: false},
        email: {
            type:DataTypes.STRING,
            validate:{
                isEmail:true,
            },
            allowNull: false,
            unique:true
        },
        password: {
            type:DataTypes.STRING,
            allowNull: false
        },
        confirm_password: {
            type: DataTypes.VIRTUAL,
            validate: {
              isMatch(value:string) {
                console.log("confirm_password value",value)
                if (value !== this.password) {
                    const err = new CustomError(`Passwords don't match`, 422);
                  throw err;
                }
              }
            }
        },
        number_of_observation: { type: DataTypes.NUMBER, defaultValue: 8,allowNull: false },
        role: {
            type:DataTypes.ENUM,
            values:USER_ROLES,
            validate: {
                isIn:[USER_ROLES]
            }
        },
        temporary_role:{
            type:DataTypes.ENUM,
            values: USER_TEMPORARY_ROLES,
            validate: {
                isIn:[USER_TEMPORARY_ROLES]
            }
        },
        city: { type: DataTypes.STRING, defaultValue: "اللاذفية" },
        is_active: { type: DataTypes.BOOLEAN, defaultValue: true,allowNull: false },
        property: {
            type:DataTypes.ENUM,
            values:USER_PROPERTIES,
            validate: {
                isIn:[USER_PROPERTIES]
            }
        },
        facultyId: {
            field: "faculty_id", // <-- this line
            type: DataTypes.BIGINT,
            allowNull: false,
            references: {
                model: "faculty",
                key: "id",
                deferrable: Deferrable.INITIALLY_IMMEDIATE(),
            },
        },
        departmentId: {
            field: "department_id", // <-- this line
            type: DataTypes.BIGINT,
            allowNull: false,
            references: {
                model: "department",
                key: "id",
                deferrable: Deferrable.INITIALLY_IMMEDIATE(),
            },
        },
        passwordChangedAt:{
            type:DataTypes.DATE,
            defaultValue: new Date(),
            allowNull:true
        }
    },
    {
        timestamps: false,
    }
) as any;
User.addScope('withoutPassword',{attributes:{exclude:['password']}});
User.beforeSave(async (instance)=>{
    instance.password=await bcrypt.hash(instance.password,12);
    console.log("beforeSave",instance)
});
User.prototype.comparePassworsInDb=async(password:string, passwordDb:string)=>{
    return await bcrypt.compare(password, passwordDb);
}
User.prototype.isPasswordsChanged=function(JWTTimestamp:number){
    let shouldDeletePassword=false;
    if(this.passwordChangedAt){
        const passwordChangedAtMs=this.passwordChangedAt.getTime()/1000;
        shouldDeletePassword=JWTTimestamp < passwordChangedAtMs;
        // console.log("JWTTimestamp",passwordChangedAtMs,JWTTimestamp)
    }
    return shouldDeletePassword;
}