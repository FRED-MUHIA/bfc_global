import { Link } from "react-router-dom";

const variants = {
  primary: "bg-pine text-white hover:bg-sage",
  secondary: "bg-sage text-white hover:bg-pine",
  light: "bg-white text-pine hover:bg-cream",
  ghost: "border border-sage/30 bg-transparent text-pine hover:bg-sage/10",
  "ghost-light": "border border-white/50 bg-transparent text-white hover:bg-white/10"
};

const sizes = {
  sm: "px-4 py-2 text-sm",
  md: "px-5 py-3 text-sm",
  lg: "px-6 py-3 text-base"
};

export default function Button({
  children,
  to,
  type = "button",
  variant = "primary",
  size = "md",
  className = "",
  onClick
}) {
  const classes = `inline-flex items-center justify-center rounded-full font-semibold tracking-wide transition ${sizes[size]} ${variants[variant]} ${className}`;

  if (to) {
    return (
      <Link to={to} className={classes} onClick={onClick}>
        {children}
      </Link>
    );
  }

  return (
    <button type={type} className={classes} onClick={onClick}>
      {children}
    </button>
  );
}
