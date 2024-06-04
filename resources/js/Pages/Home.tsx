import { router, usePage } from "@inertiajs/react";
import Divider from "@mui/material/Divider";
import AdminView from "../Components/AdminComponents/AdminView";
import UserView from "../Components/UserView";
import { Button, Drawer, Toolbar, Typography } from "@mui/material";
import React from "react";
import SideBar from "../Components/SideBar";

export default function home() {
    enum Mode {
        "user" = "user",
        "admin" = "admin",
    }
    

    let currentMode: Mode = (usePage().props.mode as Mode) ?? "ERROR";
    let user: any = usePage().props.user as any;

    React.useEffect(() => {
        console.log(currentMode);
    }, [currentMode]);

    return (
        <div style={{ marginLeft: "10px", marginRight: "10px" }}>
            
            <SideBar title={"Home"}/>
            <Button onClick={() => router.get("/logout")}>Logout</Button>
            <Divider />
            {currentMode == Mode.admin ? <AdminView /> : <UserView />}
            
        </div>
    );
}
