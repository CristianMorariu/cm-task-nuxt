export const useUser = () =>
  useState("user", () => ({
    id: null,
    name: null,
    email: null,
  }));
