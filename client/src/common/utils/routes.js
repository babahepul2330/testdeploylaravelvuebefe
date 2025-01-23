export function parseRoute(route, params = []) {
  const arrayParams = route.split("/").filter((route) => route.includes(":"));

  return route
    .split("/")
    .map((route) => {
      if (route.includes(":")) {
        const param = params[arrayParams.indexOf(route)];
        if (!param)
          throw new Error(`Missing parameter for ${route.replace(":", "")}`);
        return param;
      }

      return route;
    })
    .join("/");
}
