import { DataTypes } from "sequelize";
import { sequelize } from "../util/database";
export const Faculty = sequelize.define(
    "faculty",
    {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            allowNull: false,
            primaryKey: true,
        },
        name: DataTypes.STRING,
        location: DataTypes.STRING,
        description: DataTypes.STRING,
    },
    {
        timestamps: false,
    }
);
