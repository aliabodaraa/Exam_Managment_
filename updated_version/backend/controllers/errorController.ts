import CustomError from '../utils/CustomError'
const devErrors = (res, error) => {
    res.status(error.statusCode).json({
        status: error.statusCode,
        message: error.message,
        stackTrace: error.stack,
        error: error
    });
}

const castErrorHandler = (err) => {
    const msg = `Invalid value for ${err.path}: ${err.value}!`
    return new CustomError(msg, 400);
}

const duplicateKeyErrorHandler = (err) => {
    const name = err.keyValue.name;
    const msg = `There is already a movie with name ${name}. Please use another name!`;

    return new CustomError(msg, 400);
}

const validationErrorHandler = (err) => {
    const errors = Object.values(err.errors).map((val:any) => val.message);
    const errorMessages = errors.join('. ');
    const msg = `Invalid input data: ${errorMessages}`;

    return new CustomError(msg, 400);
}
const handleExpiredJWT = (err) => {
    const msg = `JWT has Expired , Please login again . : ${err.message}`;

    return new CustomError(msg, 400);
}
const handleJWTError = (err) => {
    const msg = `Invalid Token , Please login again . : ${err.message}`;

    return new CustomError(msg, 400);
}
const prodErrors = (res:any, error:any) => {
    if (error.isOperational) {
        res.status(error.statusCode).json({
            status: error.statusCode,
            message: error.message
        });
    } else {
        res.status(500).json({
            status: 'error',
            message: 'Something went wrong! Please try again later.'
        })
    }
}

export default (error:any, req: any,
    res: any,
    next: any) => {
    error.statusCode = error.statusCode || 500;
    error.status = error.status || 'error';
    
    if(error.name === 'SequelizeUniqueConstraintError') error = validationErrorHandler(error);

    if (process.env.NODE_ENV === 'development') {
        devErrors(res, error);
    } else if (process.env.NODE_ENV === 'production') {
        if (error.name === 'CastError') error = castErrorHandler(error);
        if (error.code === 11000) error = duplicateKeyErrorHandler(error);
        if (error.name === 'ValidationError') error = validationErrorHandler(error);
        if(error.name === 'TokenExpiredError') error = handleExpiredJWT(error);
        if(error.name === 'JsonWebTokenError') error = handleJWTError(error);

        prodErrors(res, error);
    }
}