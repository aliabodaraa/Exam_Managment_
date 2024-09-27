export default class CustomError extends Error {
    public status:'fail'|'error';
    public isOperational:boolean;
    constructor(public message:string, public statusCode:number) {
        super(message);
        this.statusCode = statusCode;
        this.status = statusCode >= 400 && statusCode < 500 ? 'fail' : 'error';

        this.isOperational = true;

        Error.captureStackTrace(this, this.constructor);
    }
}


//const error = new CustomError('some error message', 404)