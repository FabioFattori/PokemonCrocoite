import { IconButton } from "@mui/material";
import React, { CSSProperties } from "react";

function GeneralTable({
    headers = [],
    data = [],
    buttons = [],
}: {
    headers: string[];
    data: any[];
    buttons: { icon: any; url: string }[];
}) {

    const id = "table"+Math.random().toString(36).substring(7);

    React.useEffect(() => {
        let table = document.getElementById(id);
        if(table != null){
            let width = table.offsetWidth;
            if (width > window.innerWidth) {
                table.style.width = window.innerWidth * 0.9 + "px";
            }
        }else{
            console.log("Table not found");
        }
    },[]);

    let colSpan = headers.length ;

    const tableStyle: CSSProperties = {
        width: "90%",
        marginLeft:"5%",
        marginRight:"5%",
        borderCollapse: "collapse",
        textAlign: "center",
    };

    const thStyle: CSSProperties = {
        border: "1px solid black",
        padding: "8px",
        textAlign: "center",
    };

    const tdStyle: CSSProperties = {
        border: "1px solid black",
        padding: "8px",
        textAlign: "center",
    };

    

    return (
        <>
            <table style={tableStyle} id={id}>
                <thead>
                    <tr>
                        {headers.map((header, index) => (
                            <th colSpan={colSpan} key={index} style={thStyle}>
                                {header}
                            </th>
                        ))}
                    </tr>
                </thead>
                <tbody>
                    {data.map((row, index) => (
                        <tr key={index}>
                            {Object.keys(row).map((key, index) => (
                                <td style={tdStyle} colSpan={colSpan} key={index}>
                                    {row[key] != null ? row[key] : "null"}
                                </td>
                            ))}

                            <td style={buttons.length != 0 ? tdStyle:{display:"none"}}>
                                {buttons.map((button, index) => (
                                    <IconButton
                                        aria-label={button.url}
                                        size="large"
                                        onClick={() => {
                                            window.location.href = button.url;
                                        }}
                                        key={index}
                                    >
                                        {React.createElement(button.icon)}
                                    </IconButton>
                                ))}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </>
    );
}

export default GeneralTable;
