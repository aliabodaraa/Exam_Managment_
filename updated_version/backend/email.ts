import nodemailer from 'nodemailer';

export const sendEmail = async (option) => {
    //CREATE A TRANSPORTER
    const transporter = nodemailer.createTransport({
        host: process.env.MAILTRAP_EMAIL_HOST,
        // port: process.env.MAILTRAP_EMAIL_PORT,
        auth: {
            user: process.env.MAILTRAP_EMAIL_USER,
            pass: process.env.MAILTRAP_EMAIL_PASS
        }
    });
    //DEFINE EMAIL OPTIONS
    const mailOptions = {
        from: "exam-management<exam-management@gmail.com>",
        to: option.email,
        subject: option.subject,
        text: option.message
    }
    await transporter.sendMail(mailOptions);
}