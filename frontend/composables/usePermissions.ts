export function usePermissions() {
  const { user } = useAuth();
  const userCan = (permission: string): boolean => {
    return !!user.value?.abilities?.includes(permission);
  };

  return {
    userCan,
  };
}
