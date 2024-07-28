import { DataTypes, Deferrable } from "sequelize";
import { sequelize } from "../util/database";
export const User = sequelize.define(
    "user",
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            allowNull: false,
            primaryKey: true,
        },
        username: DataTypes.STRING,
        email: DataTypes.STRING,
        password: DataTypes.STRING,
        number_of_observation: { type: DataTypes.NUMBER, defaultValue: 8 },
        role: DataTypes.STRING,
        temporary_role: DataTypes.STRING,
        city: { type: DataTypes.STRING, defaultValue: "اللاذفية" },
        is_active: { type: DataTypes.BOOLEAN, defaultValue: true },
        property: DataTypes.STRING,
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
    },
    {
        timestamps: false,
    }
);
