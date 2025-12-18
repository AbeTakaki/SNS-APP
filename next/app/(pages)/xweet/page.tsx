import { getUserData, getXweet } from "@/src/lib/actions";
import React from "react";

export default async function Page() {
  let xweets;
  let userId;

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
            <p>{xweet.content} by {xweet.user.display_name} posted on {xweet.created_at}</p>
          </React.Fragment>
        ))}
      </div>
    </>
  )
}