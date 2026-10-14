import { Metadata } from "next";
import LostPasswordClient from "./LostPasswordClient";

export const metadata: Metadata = {
  title: "Lost Your Password? | Pawar Handloom By Piyush Pawar",
  description: "Reset your Pawar Handloom account password securely.",
};

export default function LostPasswordPage() {
  return <LostPasswordClient />;
}
