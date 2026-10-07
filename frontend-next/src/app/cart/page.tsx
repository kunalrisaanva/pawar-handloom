import CartClient from "./CartClient";
import SharedLayout from "../../components/SharedLayout";

export const dynamic = "force-dynamic";

export default function CartPage() {
  return (
    <SharedLayout>
      <CartClient />
    </SharedLayout>
  );
}
