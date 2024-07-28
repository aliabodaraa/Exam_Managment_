import { DataTypes, Deferrable } from "sequelize";
import { sequelize } from "../util/database";

export const Department = sequelize.define(
    "department",
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            allowNull: false,
            primaryKey: true,
        },
        name: DataTypes.STRING,
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
    },
    {
        timestamps: false,
    }
);
