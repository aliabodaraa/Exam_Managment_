import express from "express";
import { login } from "../controllers/auth";

const router = express.Router();

// /users/login => POST
router.post("/login", login);

export default router;