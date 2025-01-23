export const AUTH_ROUTE = {
  login: "/login",
  register: "/register",
  logout: "/logout",
  profile: "/profile",
  verify: "/profile/verify",
};

export const PUBLIC_ROUTE = {
  index: "/",
  product: {
    index: "/product",
    show: "/product/:id",
  },
  category: {
    index: "/category",
    show: "/category/:id",
  },
  order: {
    index: "/order",
    create: "/order/create",
    show: "/order/:id",
  },
};

export const ADMIN_ROUTE = {
  index: "/admin",
  product: {
    index: "/admin/product",
    create: "/admin/product/create",
    edit: "/admin/product/:id/edit",
  },
  category: {
    index: "/admin/category",
    create: "/admin/category/create",
    edit: "/admin/category/:id/edit",
  },
  order: {
    index: "/admin/order",
    show: "/admin/order/:id",
  },
};

const ROUTES = { ...AUTH_ROUTE, ...PUBLIC_ROUTE, admin: { ...ADMIN_ROUTE } };

export default ROUTES;
