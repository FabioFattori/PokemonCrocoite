import { router, usePage } from "@inertiajs/react";
import Divider from "@mui/material/Divider";
import AdminView from "../Components/AdminComponents/AdminView";
import UserView from "../Components/UserView";
import { Button, Drawer, Toolbar, Typography } from "@mui/material";
import React from "react";
import SideBar from "../Components/SideBar";
import userMode from "../Components/userMode";

export default function home() {
    
    

    let currentMode: userMode = (usePage().props.mode as userMode) ?? "ERROR";
    let user: any = usePage().props.user as any;


    return (
        <div style={{ marginLeft: "10px", marginRight: "10px" }}>
            
            <SideBar title={"Home"} mode={currentMode}/>
            <Button onClick={() => router.get("/logout")}>Logout</Button>
            <Divider />
            {currentMode == userMode.admin ? <AdminView /> : <UserView />}
            
        </div>
    );
}
