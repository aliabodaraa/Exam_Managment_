import { pbkdf2 } from "crypto";
import { promisify } from "util";

function generateSalt() {
    return 'aliabodaraa';
}
export const hashPassword = async (password:string) => {
    var salt = generateSalt();
    var iterations = 10000;
    var hash = await promisify(pbkdf2)(password, salt, iterations, 32, 'sha512');
    return {
        salt,
        hash,
        iterations
    };
}