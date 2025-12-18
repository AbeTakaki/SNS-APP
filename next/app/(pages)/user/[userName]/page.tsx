import React from "react";
import Link from "next/link";
import { deleteXweet, getUserData,getUserPage } from "@/src/lib/actions";
import { redirect } from "next/navigation";

type Props={
  params:Promise<{userName:string}>;
};

let data;
export default async function Page({params}:Props) {
  let loginUserId:number=0;
  try{
    const res = await getUserData();
    loginUserId = res?.id;
  }catch(e){
    console.log((e as Error).message);
  }

  try{
    const res = await getUserPage((await params).userName,loginUserId);
    data = res;
  }catch(e){
    console.log((e as Error).message);
    redirect("/error/403");
  }

  return(
    <>
      <p>ユーザ{data.displayName}のページ</p>
      <div>
        {data.xweets?.map((xweet:any)=>(
          <React.Fragment key={xweet.id}>
            {xweet.content} by {xweet.user.display_name} posted on {xweet.created_at}
            {(loginUserId && loginUserId===xweet.user.id)?<Link href={`/xweet/update/${xweet.id}`}> 更新</Link>:''}
            {(loginUserId && loginUserId===xweet.user.id)?
              <form action={
                async()=>{
                  "use server";
                  try{
                    await deleteXweet(xweet.id);
                  }catch(e){
                    console.log((e as Error).message);
                  }
                  redirect("/xweet"); 
                }
              }>
                <button type="submit"> 削除</button>
              </form>:''
            }
            <br></br>
          </React.Fragment>
        ))}
      </div>
    </>
  )
}