import express from "express";
import { forgotPassword, login, resetPassword } from "../controllers/auth";

const router = express.Router();

// /users/login => POST
router.post("/login", login);


router.post("/forgotPassword", forgotPassword);


router.patch("/resetPassword/:token", resetPassword);

export default router;