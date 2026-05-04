/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{js,jsx,ts,tsx}"],
  theme: {
    extend: {
      colors: {
        cream: "#F5F2E7",
        sand: "#E7DEC8",
        pine: "#1F5A3A",
        sage: "#2F7A4E",
        ember: "#B28A2E",
        coral: "#7FA66B",
        slate: "#2A3A31",
        mist: "#DCE7DB"
      },
      fontFamily: {
        heading: ["Lora", "Georgia", "serif"],
        body: ["Nunito Sans", "Verdana", "sans-serif"]
      },
      boxShadow: {
        soft: "0 14px 40px -22px rgba(38, 56, 52, 0.35)"
      },
      keyframes: {
        rise: {
          "0%": { opacity: "0", transform: "translateY(18px)" },
          "100%": { opacity: "1", transform: "translateY(0)" }
        },
        fadeIn: {
          "0%": { opacity: "0" },
          "100%": { opacity: "1" }
        },
        pulseSoft: {
          "0%, 100%": { opacity: "0.95", transform: "scale(1)" },
          "50%": { opacity: "1", transform: "scale(1.02)" }
        }
      },
      animation: {
        rise: "rise .75s ease-out both",
        fadeIn: "fadeIn .9s ease-out both",
        pulseSoft: "pulseSoft 4s ease-in-out infinite"
      }
    }
  },
  plugins: []
};
