import React from "react";
import translator from "../utils/EnemyType";

function DBRowDisplayer({ id,dbObject,Title }: {id:string, dbObject: any,Title:string }) {
    const [translated, setTranslated] = React.useState<any>(null);
    React.useEffect(() => {
        setTranslated(translator({ sennisTable: dbObject }));
    }, []);

    React.useEffect(() => {
        
    },[dbObject])

    const getDataInRow = (row: any) => {
        let columns = translated.columns;
        
        let fieldNamesToDisplay = translated.fieldNames.filter((field: any) => columns[field].hidden == false);
        let dataToDisplay = fieldNamesToDisplay.map((field: any) => row[field]);
        let headersToDisplay = fieldNamesToDisplay.map((field: any) => columns[field].label);
        console.log({header: headersToDisplay,data: dataToDisplay })
        return {header: headersToDisplay,data: dataToDisplay };
    }

    return <>{translated != null ? <div id={id} className="SingleRowContainer">
        <h1 className="Title">{Title}</h1>
        {translated.data.map((row: any,index:number) => {
            let {header,data} = getDataInRow(row);
            return <div id={index.toString()} className="SingleRow">
                {header.map((header: any, index: number) => {
                    return <div id={header} className="SingleRowElement">
                        <h2 style={{fontWeight:"bold"}}>{header}</h2>
                        <p>{data[index]}</p>
                    </div>
                })}
            </div>
        })}
    </div> : null}</>;
}

export default DBRowDisplayer;
