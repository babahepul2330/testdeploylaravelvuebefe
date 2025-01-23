import daisyui from "daisyui";
import daisyuiThemes from "daisyui/src/theming/themes";

/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx,vue}"],
  theme: {
    extend: {},
  },
  plugins: [daisyui],
  daisyui: {
    themes: [
      {
        lofi: {
          ...daisyuiThemes["lofi"],
          "--rounded-box": "0rem",
          "--rounded-btn": "0rem",
          "--rounded-badge": "0rem",
          "--border-btn": "2px",
          "--tab-border": "2px",
          "--tab-radius": "0rem",
        },
      },
    ],
  },
};
