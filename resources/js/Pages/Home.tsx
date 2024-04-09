import React from "react";
import GeneralTable from "../Components/GeneralTable";
import { usePage } from "@inertiajs/react";
import {buttons,setUp} from "../utils/buttons";
import Divider from '@mui/material/Divider';
import DialogForm from "../Components/DialogForm";


export default function home() {
    const [open, setOpen] = React.useState(false);

    const toggleOpen = () => {
        setOpen(!open);
    }


    React.useEffect(() => {
        console.log(users[0]["id"])
    },[]);

    let users: any[] = usePage().props.users as any[] ?? [];
    const userfieldNames = ["id",  "email"];

    const userHeaders = ["ID",  "Email"];



    

    let exemplaries : any[] = usePage().props.exemplaries as any[] ?? [];
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
        <div style={{marginLeft:"10px",marginRight:"10px"}}>
            <h1>Home</h1>
            <GeneralTable tableTitle="users" headers={userHeaders}  fieldNames={userfieldNames} data={users} buttons={buttons} />
            <Divider  />
            <GeneralTable tableTitle="Exemplaries" headers={exemplariesHeaders} fieldNames={exemplariesfieldNames} data={exemplaries} buttons={[]} />
            <DialogForm open={open} openDialog={()=>setOpen(true)} closeDialog={()=>setOpen(false)} headers={userHeaders} data={users} />
        </div>
    );
}
