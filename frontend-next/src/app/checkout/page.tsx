import CheckoutClient from "./CheckoutClient";
import SharedLayout from "../../components/SharedLayout";

export const dynamic = "force-dynamic";

export default function CheckoutPage() {
  return (
    <SharedLayout>
      <CheckoutClient />
    </SharedLayout>
  );
}
