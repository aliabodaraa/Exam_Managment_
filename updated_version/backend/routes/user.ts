import express from "express";
import { getIndex, getUser, storeUser } from "../controllers/user";

const router = express.Router();

// /users/index => GET
router.get("/index", getIndex);
router.post("/store", storeUser);
// /users/:userId => GET
router.get("/:userId", getUser);

module.exports = router;
