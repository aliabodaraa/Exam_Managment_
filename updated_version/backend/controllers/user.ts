import { Request, Response, NextFunction } from "express";
import { User } from "../models/user";
import { ITEMS_PER_PAGE, getModelDataWithPagination } from "../util/paginator";
import CustomError from "../utils/CustomError";
import { ValidationErrorItem } from "sequelize";
import jwt from 'jsonwebtoken';

export const getRoles = async (
    req: Request,
    res: Response,
    next: NextFunction
) => {
    try {
        const roles = [
            "VOC_ROLE_PROFESSOR",
            "VOC_ROLE_ENGINEER",
            "VOC_ROLE_DOCTOR",
            "VOC_ROLE_TEACHER",
            "VOC_ROLE_GRADUATE_STUDENT",
            "VOC_ADMINISTRATIVE_OFFICER",
        ];
        const temporary_roles = [
            "VOC_TEMPORARY_ROLE_DEAN",
            "VOC_TEMPORARY_ROLE_ADMINISTRATIVE_DEPUTY",
            "VOC_TEMPORARY_ROLE_SCIENTIFIC_VICE",
            "VOC_TEMPORARY_ROLE_HEAD_OF_DEPARTMENT",
            "VOC_TEMPORARY_ROLE_HEAD_OF_CIRCLE",
            "VOC_TEMPORARY_ROLE_HEAD_OF_EXAMINATIONS_DEPARTMENT",
            "VOC_TEMPORARY_ROLE_TIMEKEEPER",
            "VOC_TEMPORARY_ROLE_HEAD_OF_STUDENT_AFFAIRS",
        ];
        return res.status(200).json({ roles, temporary_roles });
    } catch (err: any) {
        console.error("ERROR FETCHING users' roles");
        console.error(err.message);
        res.status(500).json({ message: "Failed to fetch users' roles." });
    }
};
export const getIndex = async (
    req: Request,
    res: Response,
    next: NextFunction
) => {
    //go to http://127.0.0.1:3000/users/index?pageIndex=46&itermsPerPage=5&term=a&searchMode=true
    const pageIndex = +req.query.pageIndex! || 1;
    const itermsPerPage = +req.query.itermsPerPage! || ITEMS_PER_PAGE;
    const term: string = (req.query.term as string) || "";
    const searchMode = req.query.searchMode === "true";

    try {
        const {
            data,
            data_count,
            has_next,
            has_previous,
            next_page,
            previous_page,
            last_page,
            current_page,
            iterms_per_page,
            paginator_length,
        } = await getModelDataWithPagination<typeof User>(
            User,
            pageIndex,
            ["faculty", "department"],
            itermsPerPage,
            term,
            searchMode
        );
        res.status(200).json({
            data,
            data_count,
            has_next,
            has_previous,
            next_page,
            previous_page,
            last_page,
            current_page,
            iterms_per_page,
            paginator_length,
        });

        console.log("FETCHED users");
    } catch (err: any) {
        console.error("ERROR FETCHING users");
        console.error(err.message);
        res.status(500).json({ message: "Failed to load users." });
    }
};


export const getUser = async (
    req: Request,
    res: Response,
    next: NextFunction
) => {
    try {
        const user = await User.scope('withoutPassword').findByPk(req.params.id, {
            include: ["faculty", "department"],
        });
        if(!user){
            return next(new CustomError('User with that ID is not found!', 404));
        }
        res.status(200).json({message: "User Retrieved Successfully",user });
    } catch (err: any) {
        return next(err);
    }
};
const signToken=(id:string)=>{
    return jwt.sign({ id }, process.env.JWT_SECRET_STR, {expiresIn:process.env.JWT_LOGIN_EXPIRES})
}
export const storeUser = async (
    req: Request,
    res: Response,
    next: NextFunction
) => {
    try {
        const user = await User.create(req.body);
        const token = signToken(user.dataValues.id)
        res.status(201).json({ message: "User saved", user, token });
        console.log("STORED NEW User");
    } catch (err: any) {
        return next(err);
    }
};

export const updateUser = async (
    req: Request,
    res: Response,
    next: NextFunction) => {
    try{
        const updateUser = await User.findByPk(req.params.id);
        if(!updateUser){
            return next(new CustomError('User with that ID is not found!', 404));
        }
        await updateUser.update(req.body);
        res.status(200).json({message: "User Updated", user: updateUser});
    }catch(err:any){
        return next(err);
    }
}
export const deleteUser = async (
    req: Request,
    res: Response,
    next: NextFunction) => {
    try{
        const destroyedUser = await User.findByPk(req.params.id);
        if(!destroyedUser){
            return next(new CustomError('User with that ID is not found!', 404));
        }
        await destroyedUser.destroy();
        res.status(200).json({message: "User Destroyed Successfully"});
    }catch(err:any){
        return next(err);
    }
}

//   app.delete('/goals/:id', async (req, res) => {
//     console.log('TRYING TO DELETE GOAL');
//     try {
//       await Goal.deleteOne({ _id: req.params.id });
//       res.status(200).json({ message: 'Deleted goal!' });
//       console.log('DELETED GOAL');
//     } catch (err) {
//       console.error('ERROR FETCHING GOALS');
//       console.error(err.message);
//       res.status(500).json({ message: 'Failed to delete goal.' });
//     }
//   });
// exports.getIndex = (req, res, next) => {
//   const page = +req.query.page || 1;
//   let total_items;

//   // Product.find()
//   //   .countDocuments()
//   //   .then(numProducts => {
//   //     total_items = numProducts;
//   //     return Product.find()
//   //       .skip((page - 1) * ITEMS_PER_PAGE)
//   //       .limit(ITEMS_PER_PAGE);
//   //   })
//   //   .then(products => {
//   //     res.render('shop/index', {
//   //       prods: products,
//   //       pageTitle: 'Shop',
//   //       path: '/',
//   //       current_page: page,
//   //       has_next_page: ITEMS_PER_PAGE * page < total_items,
//   //       has_previousPage: page > 1,
//   //       next_page: page + 1,
//   //       previousPage: page - 1,
//   //       lastPage: Math.ceil(total_items / ITEMS_PER_PAGE)
//   //     });
//   //   })
//   //   .catch(err => {
//   //     const error = new Error(err);
//   //     error.httpStatusCode = 500;
//   //     return next(error);
//   //   });
// };
//                 Route::get('/', 'UsersController@index')->name('users.index');
//                 Route::get('/create', 'UsersController@create')->name('users.create');
//                 Route::post('/create', 'UsersController@store')->name('users.store');
//                 Route::get('/{user}/show', 'UsersController@show')->name('users.show');
//                 Route::get('/{user}/observations', 'UsersController@observations')->name('users.observations');
//                 Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
//                 Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
//                 Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
//                 Route::patch('/{user}/isActive', 'UsersController@isActive')->name('users.isActive');
//                 Route::get('/{user}/profile', 'UsersController@profile')->name('users.profile');
//                 Route::get('/{user}/create_user_courses', 'UsersController@create_user_courses')->name('users.create_user_courses');
//                 Route::post('/{user}/store_user_courses', 'UsersController@store_user_courses')->name('users.store_user_courses');
//                 Route::get('/{user}/edit_user_courses', 'UsersController@edit_user_courses')->name('users.edit_user_courses');
//                 Route::patch('/{user}/update_user_courses', 'UsersController@update_user_courses')->name('users.update_user_courses');
//                 Route::delete('/{user}/courses_teach/{course}/destroy_user_courses', 'UsersController@destroy_user_courses')->name('users.destroy_user_courses');

//                 Route::patch('/setObservations', 'UsersController@setObservations')->name('users.setObservations');

//                 Route::get('/search', 'UsersController@search')->name('users.search');

//                 //Excel
//                 Route::get('/observations-export/{rotation}', 'RotationsController@exportObservations')->name('observations.export');
