import React from "react";
import XweetList from "@/src/lib/components/xweet/xweetlist";
import { getXweet,getUserData } from "@/src/lib/actions";

export default async function Page() {
  let xweets;
  let userId;
  try{
    const res = await getUserData();
    userId = res.id;
  }catch(e){
    console.log((e as Error).message);
  }

  try{
    const res = await getXweet(userId);
    xweets = res.xweets;
  }catch(e){
    console.log((e as Error).message);
  }

  return(
    <>
      <div>
        <XweetList loginUserId={userId} xweets={xweets} />
      </div>
    </>
  )
}