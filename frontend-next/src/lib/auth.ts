export interface AuthUser {
  id: number;
  name: string;
  email: string;
  role?: number;
}

const STORAGE_KEY = "pawar_user";

export function getStoredUser(): AuthUser | null {
  if (typeof window === "undefined") return null;
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (!raw) return null;
    return JSON.parse(raw);
  } catch (e) {
    console.error("Error reading stored user:", e);
    return null;
  }
}

export function setStoredUser(user: AuthUser): void {
  if (typeof window === "undefined") return;
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(user));
    // Set cookie for SSR compatibility
    document.cookie = `pawar_user_id=${user.id}; path=/; max-age=604800; SameSite=Lax`;
    window.dispatchEvent(new Event("auth_change"));
  } catch (e) {
    console.error("Error saving stored user:", e);
  }
}

export function clearStoredUser(): void {
  if (typeof window === "undefined") return;
  try {
    localStorage.removeItem(STORAGE_KEY);
    document.cookie = "pawar_user_id=; path=/; max-age=0; SameSite=Lax";
    window.dispatchEvent(new Event("auth_change"));
  } catch (e) {
    console.error("Error clearing stored user:", e);
  }
}

export async function logoutUser(redirectPath: string = "/customer-login"): Promise<void> {
  try {
    await fetch("http://localhost:8080/logout?format=json", {
      method: "POST",
      credentials: "include",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
      },
    });
  } catch (err) {
    console.warn("Backend logout error (proceeding with local cleanup):", err);
  } finally {
    clearStoredUser();
    if (typeof window !== "undefined") {
      window.location.href = redirectPath;
    }
  }
}
