import React from "react";
import GeneralTable from "../Components/GeneralTable";
import { usePage } from "@inertiajs/react";
import AddIcon from '@mui/icons-material/Add';
import  Edit  from "@mui/icons-material/Edit";
import Divider from '@mui/material/Divider';


export default function home() {
    let users: any[] = usePage().props.users as any[];
    const userHeaders = ["id", "Name", "Email","buttons"];

    const buttons = [{ icon: AddIcon, url: "/" },{icon: Edit, url: "/edit"}];

    let exemplaries : any[] = usePage().props.exemplaries as any[];
    const exemplariesHeaders = ["id", 'speed',
    'specialDefense',
    'defense',
    'attack',
    'specialAttack',
    'ps',
    'level',
    'catchDate',
    'pokemon_id',
    'gender_id',
    'nature_id',
    'user_team_id',
    'npc_id',
    'holding_tools_id',
    'box_id',];

    return (
        <div>
            <h1>Home</h1>
            <GeneralTable headers={userHeaders} data={users} buttons={buttons} />
            <Divider  />
            <GeneralTable headers={exemplariesHeaders} data={exemplaries} buttons={[]} />
        </div>
    );
}
