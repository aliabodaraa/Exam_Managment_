import express from "express";
import { getIndex, getRoles, getUser, storeUser, updateUser,deleteUser } from "../controllers/user";
import { protect, restrict } from "../controllers/auth";

const router = express.Router();

// /users/roles => GET
router.get("/roles", getRoles);

router.route('/').get(protect, getIndex).post(storeUser);
router.route('/:id').get(getUser).patch(updateUser).delete(protect, restrict('VOC_ROLE_ADMIN','VOC_TEMPORARY_ROLE_DEAN'), deleteUser);

export default router;
