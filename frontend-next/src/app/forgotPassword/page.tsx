import { Metadata } from "next";
import LostPasswordClient from "../lost-password/LostPasswordClient";

export const metadata: Metadata = {
  title: "Forgot Password | Pawar Handloom By Piyush Pawar",
  description: "Reset your Pawar Handloom account password.",
};

export default function ForgotPasswordPage() {
  return <LostPasswordClient />;
}
