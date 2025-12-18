import { deleteXweet } from "../../lib/actions";
import Link from "next/link";
import { redirect } from "next/navigation";
import React from "react";
import { xweet } from "../../types/types"

type Props = {
  loginUserId: number;
  xweets: xweet[];
}

export default function XweetList({loginUserId,xweets}:Props){
  return(
    <>
      <div className="bg-white rounded-md shadow-lg mt-5 mb-5 overflow-auto">
        <ul>
          {xweets?.map((xweet:xweet)=>(
            <li className="border-b last:border-0 border-gray-200 p-4" key={xweet.id}>
              
              <div className="flex">
              
                <div className="ml-4">
                  <span className="inline-block rounded-full px-2 py-1 text-s font-bold mb-1">
                    <Link href={`/user/${xweet.user?.user_name}`}>{xweet.user?.display_name}</Link>
                  </span> 
                  <p id="xweet-content" className="text-gray-600 px-2 mb-1">{xweet.content}</p>
                </div>
              </div>

              <p className="text-xs text-right">posted on {(()=>{
                const str:string = `${xweet.created_at}`;
                const str1:string = str.substring(0,10);
                const str2:string = str.substring(11,19);
                return str1+" "+str2;
              })()}</p>

              {(loginUserId && loginUserId===xweet.user?.id)?
                <div className="mt-2 text-xs text-right">
                  <span className="mr-1"><Link id="xweet-update" href={`/xweet/update/${xweet.id}`}> 更新</Link></span>
                  <form className="inline" action={
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
                    <button id="xweet-delete" type="submit"> 削除</button>
                  </form>
                </div>
              :''}
            </li>
          ))}
        </ul>
      </div>
    </>
  )
}