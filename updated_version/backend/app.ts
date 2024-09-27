const path = require("path");
import { Request, Response, NextFunction } from "express";
import express from "express";
import bodyParser from "body-parser";
import { get404 } from "./controllers/error";
import { User } from "./models/user";
import { Department } from "./models/departmant";
import { Faculty } from "./models/faculty";
import CustomError from "./utils/CustomError";
import globalErrorHandler from './controllers/errorController';
import authRoutes from './routes/auth';
import userRoutes from './routes/user';

const app = express();

app.set("view engine", "ejs");
app.set("views", "views");

app.use((req: any, res, next) => {
    User.findByPk(2).then((user) => {
        req.user = user;
        next();
    });
});


app.use(bodyParser.urlencoded({ extended: false }));

app.use(express.static(path.join(__dirname, "public")));
app.use((req, res, next) => {
    res.setHeader("Access-Control-Allow-Origin", "*");
    res.setHeader("Access-Control-Allow-Methods", "GET, POST, DELETE, OPTIONS");
    res.setHeader("Access-Control-Allow-Headers", "Content-Type");
    next();
});
app.use("/users", userRoutes);
app.use("/users", authRoutes);

// app.use(shopRoutes);
app.all('*', (req: Request,
    res: Response,
    next: NextFunction) => {
    const err = new CustomError(`Can't find ${req.originalUrl} on the server!`, 404);
    next(err);
});
app.use(globalErrorHandler);

app.use(get404);

//relationships

//Department vs. User
User.belongsTo(Department, { constraints: true, onDelete: "CASCADE" });
Department.hasMany(User);
//User vs. Faculty
User.belongsTo(Faculty, { constraints: true, onDelete: "CASCADE" });
Faculty.hasMany(User);
//Department vs. Faculty
Department.belongsTo(Faculty, { constraints: true, onDelete: "CASCADE" });
Faculty.hasMany(Department);
//1. Product - User
// Product.belongsTo(User,{constraints:true, onDelete:'CASCADE'});
// User.hasMany(Product);

//2. User - Cart
// User.hasOne(Cart)
// Cart.belongsTo(User)

// //3. Cart - Product
// Cart.belongsToMany(Product, {through : CartItem})
// Product.belongsToMany(Cart, {through : CartItem})

// //3. Order - User
// Order.belongsTo(User)
// User.hasMany(Order);

// //3. Order - Product
// Order.belongsToMany(Product, {through : OrderItem}) //make you call `order.getProducts()`
// Product.belongsToMany(Order, {through : OrderItem}) //make you call `product.getOrders()`

// // sequelize.sync({force:true}).    //reconsidering the relationship that we newly setup
console.log("--------ali abodaraa--------");
export default app