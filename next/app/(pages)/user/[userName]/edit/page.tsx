import Auth from "@/src/components/auth";
import EditForm from "@/src/components/user/editform";
import { canEditProfile } from "@/src/lib/actions";
import { redirect } from "next/navigation";

type Props={
  params:Promise<{userName:string}>;
};

export default async function Page({params}:Props) {
  let data;
  try{
    const res = await canEditProfile((await params).userName);
    data = res;
  }catch(e){
    console.log((e as Error).message);
    redirect("/error/403");
  }

  return(
    <>
      <Auth>
        <EditForm userName={data.user_name} displayName={data.display_name} profile={data.profile} />
      </Auth>
    </>
  )
}