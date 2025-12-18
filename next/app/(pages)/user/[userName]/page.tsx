import React from "react";
import Link from "next/link";
import { createFollow,deleteFollow,deleteXweet, getUserData,getUserPage } from "@/src/lib/actions";
import { redirect } from "next/navigation";
import { revalidatePath } from "next/cache";

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

    const tryCreateFollow = async() =>{
    "use server";
    try{
      await createFollow((await params).userName);
      const res = await getUserPage((await params).userName,loginUserId);
      data = res;
    }catch(e){
      console.log((e as Error).message);
      redirect("/error/403");
    }
    revalidatePath(`/user/${(await params).userName}`);
  }

  const tryDeleteFollow = async() =>{
    "use server";
    try{
      await deleteFollow((await params).userName);
      const res = await getUserPage((await params).userName,loginUserId);
      data = res;
    }catch(e){
      console.log((e as Error).message);
      redirect("/error/403");
    }
    revalidatePath(`/user/${(await params).userName}`);
  }

  return(
    <>
      <p>ユーザ{data.displayName}のページ</p>
      {(loginUserId && loginUserId!==data.id && !data.isFollowing)?<form action={tryCreateFollow}><button type="submit">フォローする</button></form>:''}
      {(loginUserId && loginUserId!==data.id && data.isFollowing)?<form action={tryDeleteFollow}><button type="submit">フォロー解除</button></form>:''}

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