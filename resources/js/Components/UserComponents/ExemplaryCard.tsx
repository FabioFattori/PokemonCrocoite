import { usePage } from '@inertiajs/react';
import React from 'react'

function ExemplaryCard({data}:{data:any}) {
    let rarities = usePage().props.rarities as any[] ?? [];
  React.useEffect(() => {
    console.log(rarities)
  },[]);

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

  return (
    <div className='ExemplaryCard'>
        <h1>{data.name}</h1>
        <p>{resolveRarity(data.rarity_id)}</p>
    </div>
  )
}

export default ExemplaryCard