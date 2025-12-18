import { getUserData, getXweet } from "@/src/lib/actions";
import Link from "next/link";
import React from "react";

export default async function Page() {
  let xweets;
  let userId:null|number =null;

  try {
    const res = await getUserData();
    userId = res.id;
  } catch (e) {
    console.log((e as Error).message);
  }

  try {
    const res = await getXweet(userId);
    xweets = res.xweets;
  } catch (e) {
    console.log((e as Error).message);
  }

  return(
    <>
      <div>
        {xweets?.map((xweet:any) =>(
          <React.Fragment key={xweet.id}>
            {xweet.content} by {xweet.user.display_name} posted on {xweet.created_at}
            {(userId && userId===xweet.user.id)?<Link href={`/xweet/update/${xweet.id}`}> 更新</Link>:''}
            <br></br>
          </React.Fragment>
        ))}
      </div>
    </>
  )
}