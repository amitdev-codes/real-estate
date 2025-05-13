// usePermissions.js
import { usePage } from '@inertiajs/vue3';

export function usePermissions() {
  const page = usePage();

  const can = (permission) => {
    return page.props.auth.user?.permissions.includes(permission) || false;
  };

  const hasRole = (role) => {
    return page.props.auth.user?.roles.includes(role) || false;
  };

  return { can, hasRole };
}
