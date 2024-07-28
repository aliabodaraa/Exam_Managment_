import { Request, Response, NextFunction } from "express";
import { User } from "../models/user";
import { ITEMS_PER_PAGE, getDataWithPagination } from "../util/paginator";

export const getIndex = async (
    req: Request,
    res: Response,
    next: NextFunction
) => {
    //go to http://127.0.0.1:3000/users/index?page=46
    const pageIndex = +req.query.pageIndex! || 1;
    const itermsPerPage = +req.query.itermsPerPage! || ITEMS_PER_PAGE;

    try {
        const {
            data,
            data_count,
            has_next,
            remaining_items,
            has_previous,
            next_page,
            previous_page,
            last_page,
            current_page,
            iterms_per_page,
        } = await getDataWithPagination(
            User,
            pageIndex,
            ["faculty", "department"],
            itermsPerPage
        );
        res.status(200).json({
            data,
            data_count,
            has_next,
            remaining_items,
            has_previous,
            next_page,
            previous_page,
            last_page,
            current_page,
            iterms_per_page,
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
        const data = await User.findByPk(req.params.userId, {
            include: ["faculty", "department"],
        });
        res.status(200).json({ data });

        console.log("FETCHED users");
    } catch (err: any) {
        console.error("ERROR FETCHING users");
        console.error(err.message);
        res.status(500).json({ message: "Failed to load users." });
    }
};
export const storeUser = async (
    req: Request,
    res: Response,
    next: NextFunction
) => {
    let {
        email,
        username,
        password,
        role,
        temporary_role,
        facultyId,
        departmentId,
        number_of_observation,
        city,
        property,
    } = req.body;
    console.log(req.body, "HERRRRRRE");
    let modified_property = "";
    if (property === "1") modified_property = "عضو هيئة فنية";
    else if (property === "2") modified_property = "عضو هيئة تدريسية";

    try {
        const user = await User.create({
            email,
            username,
            password,
            role,
            temporary_role,
            facultyId,
            departmentId,
            number_of_observation,
            city,
            property: modified_property,
        });
        res.status(201).json({ message: "User saved", user });
        console.log("STORED NEW User");
    } catch (err: any) {
        console.error("ERROR In STORED NEW User");
        console.error(err.message);
        res.status(500).json({ message: "Failed to save user." });
    }
};

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
