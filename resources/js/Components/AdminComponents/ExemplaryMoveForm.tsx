import { router } from "@inertiajs/react";
import {
    Button,
    Dialog,
    DialogContent,
    DialogTitle,
    FormControl,
    InputLabel,
    MenuItem,
    Select,
} from "@mui/material";
import React from "react";

function ExemplaryMoveForm({
    isOpen,
    openDialog,
    closeDialog,
    allLearnableMoves,
    moves,
    exemplary_id
}: {
    isOpen: boolean;
    openDialog: () => void;
    closeDialog: () => void;
    allLearnableMoves: any[];
    moves: any;
    exemplary_id: number;
}) {

    const [newMoves, setNewMoves] = React.useState(-1);
    const ChangeInput = (value: any) => {
        setNewMoves(value);
    };

    return (
        <Dialog
            style={{ width: "100%" }}
            open={isOpen}
            onClose={closeDialog}
            PaperProps={{
                component: "form",
                onSubmit: (event: React.FormEvent<HTMLFormElement>) => {
                    event.preventDefault();
                    const formData = new FormData(event.currentTarget);
                    const formJson = Object.fromEntries(
                        (formData as any).entries()
                    );
                    const email = formJson.email;
                    closeDialog();
                },
            }}
        >
            <DialogTitle>
                {moves != undefined && moves.length != 0
                    ? "Modifica"
                    : "Aggiungi"}
            </DialogTitle>
            <DialogContent style={{ width: "400px" }}>
                <FormControl fullWidth>
                    <InputLabel id="demo-simple-select-label">Mossa</InputLabel>
                    <Select
                        labelId="demo-simple-select-label"
                        id="demo-simple-select"
                        value={newMoves != -1 ? newMoves : ""}
                        label="Mossa"
                        onChange={(e) => {
                            ChangeInput(e.target.value);
                        }}
                    >
                        {allLearnableMoves.length != 0
                            ? allLearnableMoves[
                                  "level" as unknown as number
                              ].map((item: any) => {
                                  return (
                                      <MenuItem value={item.id}>
                                          {item.name}
                                      </MenuItem>
                                  );
                              })
                            : null}
                        {allLearnableMoves.length != 0
                            ? allLearnableMoves[
                                  "machine" as unknown as number
                              ].map((item: any) => {
                                  return (
                                      <MenuItem value={item.id}>
                                          {item.name}
                                      </MenuItem>
                                  );
                              })
                            : null}
                    </Select>
                    <Button
                        variant="contained"
                        color="primary"
                        onClick={() => router.post("/admin/changeMove",{exemplary_id: exemplary_id, moveOld_id: moves.id, moveNew_id: newMoves})}
                    >
                        Submit
                    </Button>
                </FormControl>
            </DialogContent>
        </Dialog>
    );
}

export default ExemplaryMoveForm;
