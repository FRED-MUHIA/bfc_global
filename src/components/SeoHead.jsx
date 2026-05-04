import { useEffect } from "react";
import { organization } from "../data/siteContent";

export default function SeoHead({ title, description }) {
  useEffect(() => {
    document.title = title ? `${title} | ${organization.name}` : organization.name;

    const metaDescription = document.querySelector("meta[name='description']");
    if (metaDescription) {
      metaDescription.setAttribute("content", description || organization.mission);
    }
  }, [title, description]);

  return null;
}
