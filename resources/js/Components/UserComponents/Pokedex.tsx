import { usePage } from "@inertiajs/react";
import React from "react";

function Pokedex() {
    let pokemon = (usePage().props.pokedex as any[]) ?? [];
    let rarities = (usePage().props.rarities as any[]) ?? [];
    const resolveRarity = (rarity: number) => {
        let rarityName = rarities.find(
            (rarityObj) => rarityObj.id == rarity
        )?.name;
        return mixTextWithEmoji(rarityName);
    };

    const mixTextWithEmoji = (text: string) => {
        let emoji = "";
        switch (text.toLowerCase()) {
            case "common":
                emoji = "🟦";
                break;
            case "uncommon":
                emoji = "🟩";
                break;
            case "rare":
                emoji = "🟨";
                break;
            case "very rare":
                emoji = "🟥";
                break;
            case "legendary":
                emoji = "🟪";
                break;
            default:
                emoji = "";
        }
        return emoji + " " + text;
    }

    const mixTextWithQuestionMark = (text: string,encountered:boolean) => {
        // substitute a random number of characters with a question mark
        let textArray = text.split("");
        let textArrayLength = textArray.length;
        let randomIndex = encountered?textArrayLength / 2:textArrayLength

        if(!encountered){
            let toRet = "";
            for(let i = 0; i<randomIndex; i++){
                toRet += "?";
            }
            return toRet; 
        }

        for(let i = 0; i<randomIndex; i++){
            let index = Math.floor(Math.random() * textArrayLength);
            textArray[index] = "?";
        }

        return textArray.join("");


    }


    return (
        <div
            style={{
                display: "flex",
                justifyContent: "center",
                flexWrap: "wrap",
            }}
        >
            {pokemon.map((pokemon) => {
                return (
                    <div className="ExemplaryCard">
                        {pokemon.captured ? <>
                            <h1>{pokemon.name}</h1>
                            <p>{resolveRarity(pokemon.rarity_id)}</p></>: pokemon.encountered ? 
                            <>
                            <h1>{mixTextWithQuestionMark(pokemon.name,true)}</h1>
                            <p>{mixTextWithQuestionMark(resolveRarity(pokemon.rarity_id),true)}</p>
                            </>:
                            <>
                            <h1>{mixTextWithQuestionMark(pokemon.name,false)}</h1>
                            <p>{mixTextWithQuestionMark(resolveRarity(pokemon.rarity_id),false)}</p>
                            </>}
                    </div>
                );
            })}
        </div>
    );
}

export default Pokedex;
