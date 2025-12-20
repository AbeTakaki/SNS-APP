import Auth from "@/src/components/auth";
import EditForm from "@/src/components/user/editform";
import { canEditProfile } from "@/src/lib/actions";
import { errorRedirect } from "@/src/lib/navigations";

type Props={
  params:Promise<{userName:string}>;
};

export default async function Page({params}:Props) {
  let data;
  try{
    const res = await canEditProfile((await params).userName);
    data = res;
  }catch(e){
    await errorRedirect((e as Error & { statusCode?: number }).statusCode);
    throw new Error("予期せぬエラーが発生しました");
  }

  return(
    <>
      <Auth>
        <EditForm userName={data.user_name} displayName={data.display_name} profile={data.profile} />
      </Auth>
    </>
  )
}