import { usePage } from "@inertiajs/react";
import { useState } from "react";
import { router } from "@inertiajs/react";
import landingImage from "./../../img/landing.jpg";

function Login() {
    const [mode, setMode] = useState(usePage().props.mode ?? "login");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");

    const login = () => {
        router.get(
            "/tryLogin",
            { email: email, password: password, mode: mode.toString() },
            {
                onError: (e) => {
                    setError(e.email);
                },
            }
        );
    };

    const register = (mode: boolean) => {
        if (password !== confirmPassword) {
            setError("Passwords do not match");
        } else {
            mode
                ? router.post(
                      "/register",
                      { email: email, password: password },
                      {
                          onError: (e) => {
                              setError(e.email);
                          },
                      }
                  )
                : router.post(
                      "/registerAdmin",
                      { email: email, password: password },
                      {
                          onError: (e) => {
                              setError(e.email);
                          },
                      }
                  );
        }
    };

    return (
        <div className="login-form">
            <div>
                <div>
                    <h1 className="Title">{mode}</h1>
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        onChange={(e) => setEmail(e.target.value)}
                        value={email}
                    />
                </div>
                <div>
                    <label>Password</label>
                    <input
                        type="password"
                        name="password"
                        onChange={(e) => setPassword(e.target.value)}
                        value={password}
                    />
                </div>
                {mode === "register" ? (
                    <div>
                        <label>Confirm Password</label>
                        <input
                            type="password"
                            name="password"
                            onChange={(e) => setConfirmPassword(e.target.value)}
                            value={confirmPassword}
                        />
                    </div>
                ) : null}

                {mode !== "register" ? (
                    <div>
                        <button
                            onClick={() =>
                                mode === "login"
                                    ? setMode("admin")
                                    : setMode("login")
                            }
                        >
                            {mode === "login" ? "admin?" : "normal User?"}
                        </button>
                        <button onClick={login}>Login</button>
                    </div>
                ) : (
                    <div>
                        <button onClick={() => register(true)}>Register</button>
                        <button onClick={() => register(false)}>
                            Register Admin
                        </button>
                    </div>
                )}
                {mode !== "register" ? (
                    <button onClick={() => setMode("register")}>
                        Register
                    </button>
                ) : (
                    <button onClick={() => setMode("login")}>Login</button>
                )}

                <div className="error">{error}</div>
            </div>
        </div>
    );
}

export default Login;
