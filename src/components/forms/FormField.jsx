export default function FormField({
  label,
  name,
  type = "text",
  placeholder,
  required = false,
  as = "input",
  rows = 4
}) {
  const commonClasses =
    "w-full rounded-xl border border-sand bg-white px-4 py-3 text-sm text-slate outline-none transition focus:border-sage focus:ring-2 focus:ring-sage/20";

  return (
    <label className="block">
      <span className="mb-2 block text-sm font-semibold text-pine">
        {label}
        {required ? " *" : ""}
      </span>
      {as === "textarea" ? (
        <textarea
          name={name}
          rows={rows}
          required={required}
          placeholder={placeholder}
          className={commonClasses}
        />
      ) : (
        <input
          type={type}
          name={name}
          required={required}
          placeholder={placeholder}
          className={commonClasses}
        />
      )}
    </label>
  );
}
