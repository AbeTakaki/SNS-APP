import React from "react";
import XweetList from "@/src/components/xweet/xweetlist";
import { getXweet,getUserData } from "@/src/lib/actions";
import { errorRedirect } from "@/src/lib/navigations";
export const dynamic = 'force-dynamic';

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
    await errorRedirect((e as Error & { statusCode?: number }).statusCode);
    throw new Error("予期せぬエラーが発生しました");
  }

  return(
    <>
      <div>
        <XweetList loginUserId={userId} xweets={xweets} />
      </div>
    </>
  )
}