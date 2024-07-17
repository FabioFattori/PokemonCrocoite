import "./bootstrap";
import "../css/app.css";

import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { LocalizationProvider } from "@mui/x-date-pickers";
import { AdapterDayjs } from "@mui/x-date-pickers/AdapterDayjs";
import { colors, createTheme, ThemeProvider } from "@mui/material";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.tsx`,
            import.meta.glob("./Pages/**/*.tsx")
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <ThemeProvider
                theme={createTheme({
                    palette: {
                        primary: {
                            main: colors.pink[400],
                        },
                    },
                })}
            >
                <LocalizationProvider dateAdapter={AdapterDayjs}>
                    <App {...props} />
                </LocalizationProvider>
            </ThemeProvider>
        );
    },
    progress: {
        color: "#4B5563",
    },
});
