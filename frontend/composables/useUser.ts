export type AuthUser = { id: number; username: string; email: string } | null;

export const useUser = () => useState<AuthUser>("user", () => null);
