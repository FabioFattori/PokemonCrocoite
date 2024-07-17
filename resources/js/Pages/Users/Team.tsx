import React from "react";
import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button, buttons, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import SentimentVeryDissatisfiedIcon from "@mui/icons-material/SentimentVeryDissatisfied";
import ArchiveIcon from '@mui/icons-material/Archive';
import FormSpostaInBox from "../../Components/UserComponents/FormSpostaInBox";

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
            label: "Libera Pokemon",
            icon: SentimentVeryDissatisfiedIcon,
            method: ({ props }: { props: any }) => {
                router.post("/user/exemplary/free", { id: props[0].id });
            },
        },
        {
            label: "Sposta in un Box",
            icon: ArchiveIcon,
            method: ({ props }: { props: any }) => {
                setExe(props[0]);
                openDialog();
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
            <FormSpostaInBox open={open} closeDialog={closeDialog} exe={exe} />
        </>
    );
}

export default Team;
