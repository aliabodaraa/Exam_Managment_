import { User } from "./models/user";
import sequelize from "./util/database";
import dotenv from 'dotenv';
import app  from "./app";

dotenv.config({path: './config.env'});
console.log(process.env.NODE_ENV,"dotenv")
process.on('uncaughtException', (err) => {
    console.log(err.name, err.message);
    console.log('Uncaught Exception occured! Shutting down...');
    process.exit(1);
 })


//console.log(app.get('env'));
console.log(process.env);

let server;
const port = process.env.PORT || 80;
sequelize
    .sync()
    .then((result) => {
        console.log('Sequelize DB Connection Successful');
        return User.findByPk(2, { include: ["faculty", "department"] });
    })
    .then((result) => {
        console.log(result);
        console.log(
            result?.dataValues.faculty.id,
            result?.dataValues.department.id
        );
    })
    .then(() => {
        server=app.listen(port);
        console.log('server has started...');
    })
    .catch((err) => console.log(err));




process.on('unhandledRejection', (err:any) => {
   console.log(err.name, err.message);
   console.log('Unhandled rejection occured! Shutting down...');

   server.close(() => {
    process.exit(1);
   })
})



