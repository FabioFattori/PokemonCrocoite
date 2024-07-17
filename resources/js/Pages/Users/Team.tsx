import React from "react";
import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button, buttons, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import ArchiveIcon from '@mui/icons-material/Archive';
import FormSpostaInBox from "../../Components/UserComponents/FormSpostaInBox";
import SignLanguageIcon from '@mui/icons-material/SignLanguage';
function Team() {
    var exemplaries = (usePage().props.teams as any[]) ?? null;
    const [exe,setExe] = React.useState(null);
    const [open, setOpen] = React.useState(false);
    const closeDialog = () => {
        setOpen(false);
    }

    const openDialog = () => {
        setOpen(true);
    }

    React.useEffect(() => {
        closeDialog();
        setExe(null);
    },[exemplaries]);

    setTableToUse("exemplaries");
    let btn = [
        {
            label: "Sposta in un Box",
            icon: ArchiveIcon,
            method: ({ props }: { props: any }) => {
                setExe(props[0]);
                openDialog();
            },
        },
        {
            label: "mostra Mosse",
            icon: SignLanguageIcon,
            method: ({ props }: { props: any }) => {
                router.get("/user/moves",{id:props[0].id});
            },
        },
    ] as unknown as Button[];
    return (
        <>
            <SideBar title={"Team Corrente"} mode={userMode.user} />
            <GeneralTable
                tableTitle="Team"
                dbObject={exemplaries}
                buttons={btn}
            />
            {open ? <FormSpostaInBox open={open} closeDialog={closeDialog} exe={exe} />:null}
        </>
    );
}

export default Team;
