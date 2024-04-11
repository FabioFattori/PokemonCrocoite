
function translator({sennisTable}:{sennisTable: any}) {
    console.log(sennisTable)
    const headers = Object.keys(sennisTable["column"]).map((key: any) => sennisTable["column"][key]["label"]) as string[];
    const fieldNames = Object.keys(sennisTable["column"]).map((key: any) => sennisTable["column"][key]["name"]) as string[];
    const data = sennisTable["data"]
    const page = sennisTable["page"] as number ?? 1;
    const dataPerPage = sennisTable["perPage"] as number ?? 10;
    const count = sennisTable["count"] as number ?? 0;

    console.log({headers , fieldNames , data , page , dataPerPage , count})

    return {headers , fieldNames , data , page , dataPerPage , count}
}

export default translator;