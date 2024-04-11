import React from "react";
import GeneralTable from "../Components/GeneralTable";
import { usePage } from "@inertiajs/react";
import {buttons,setUp} from "../utils/buttons";
import Divider from '@mui/material/Divider';


export default function home() {

    
    
    let users: any[] = usePage().props.users as any[] ?? [];



    return (
        <div style={{marginLeft:"10px",marginRight:"10px"}}>
            <h1>Home</h1>
            <GeneralTable tableTitle="users" dbObject={users} buttons={buttons} />
        </div>
    );
}
