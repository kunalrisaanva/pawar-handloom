import { Metadata } from "next";
import ContactClient from "./ContactClient";

export const metadata: Metadata = {
  title: "Contact Us | Pawar Handloom By Piyush Pawar",
  description:
    "Get in touch with Pawar Handloom in Indore. Contact us for authentic Maheshwari & Chanderi sarees, bulk wholesale inquiries, reseller partnerships, or customer assistance.",
  openGraph: {
    title: "Contact Us | Pawar Handloom",
    description:
      "Reach out to Pawar Handloom for handloom sarees, bulk orders, and customer queries.",
    url: "https://pawarhandloom.com/contact",
    siteName: "Pawar Handloom",
    type: "website",
  },
};

export default function ContactPage() {
  return <ContactClient />;
}
