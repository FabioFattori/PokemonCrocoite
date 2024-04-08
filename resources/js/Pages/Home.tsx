import React from "react";
import GeneralTable from "../Components/GeneralTable";
import { usePage } from "@inertiajs/react";
import AddIcon from '@mui/icons-material/Add';
import  Edit  from "@mui/icons-material/Edit";
import Divider from '@mui/material/Divider';


export default function home() {
    let users: any[] = usePage().props.users as any[];
    const userfieldNames = ["id",  "email"];

    const userHeaders = ["ID",  "Email"];

    const buttons = [{ icon: AddIcon, url: "/" },{icon: Edit, url: "/edit"}];

    let exemplaries : any[] = usePage().props.exemplaries as any[];
    const exemplariesfieldNames = ["id", 'speed',
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

    const exemplariesHeaders = ["ID", 'Speed',
    'Special Defense',
    'Defense',
    'Attack',
    'Special Attack',
    'PS',
    'Level',
    'Catch Date',
    'Pokemon ID',
    "Gender ID",
    "Nature ID",
    "User Team ID",
    "NPC ID",
    "Holding Tools ID",
    "Box ID",];


    return (
        <div>
            <h1>Home</h1>
            <GeneralTable tableTitle="users" headers={userHeaders}  fieldNames={userfieldNames} data={users} buttons={buttons} />
            <Divider  />
            <GeneralTable tableTitle="Exemplaries" headers={exemplariesHeaders} fieldNames={exemplariesfieldNames} data={exemplaries} buttons={[]} />
        </div>
    );
}
