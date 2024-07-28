import { Dialect, Sequelize } from "sequelize";
// environment variables

console.log("Sequelize")
const DB_TYPE = (process.env.DB_TYPE as Dialect) || "mysql";
const HOST = process.env.SERVICE_NAME || "localhost";
const MYSQL_DB = process.env.MYSQL_DB || "exam_time_managment";
const MYSQL_USER = process.env.MYSQL_USER || "root";
const MYSQL_PASSWORD = process.env.MYSQL_PASSWORD || "MasterR540";
export const sequelize = new Sequelize(MYSQL_DB, MYSQL_USER, MYSQL_PASSWORD, {
    dialect: "mysql",
    host: HOST,
});
