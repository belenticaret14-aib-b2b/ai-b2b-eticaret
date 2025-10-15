page 50000 "Merhaba Greeting"
{
    PageType = Card;
    ApplicationArea = All;
    UsageCategory = Administration;
    Caption = 'Merhaba Greeting';

    layout
    {
        area(Content)
        {
            group(Greeting)
            {
                Caption = 'Greeting';
                
                field(GreetingMessage; GreetingText)
                {
                    ApplicationArea = All;
                    Caption = 'Greeting Message';
                    Editable = false;
                    Style = Strong;
                    StyleExpr = true;
                }
            }
        }
    }

    actions
    {
        area(Processing)
        {
            action(ShowGreeting)
            {
                ApplicationArea = All;
                Caption = 'Show Greeting';
                Image = Message;
                Promoted = true;
                PromotedCategory = Process;
                PromotedIsBig = true;

                trigger OnAction()
                var
                    MerhabaCodeunit: Codeunit "Merhaba Codeunit";
                begin
                    Message(MerhabaCodeunit.GetGreeting());
                end;
            }
        }
    }

    var
        GreetingText: Text;

    trigger OnOpenPage()
    var
        MerhabaCodeunit: Codeunit "Merhaba Codeunit";
    begin
        GreetingText := MerhabaCodeunit.GetGreeting();
    end;
}
