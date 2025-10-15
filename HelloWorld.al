pageextension 50100 MerhabaGreeting extends "Customer List"
{
    trigger OnOpenPage()
    begin
        Message('Merhaba! Welcome to Business Central!');
    end;

    actions
    {
        addfirst(processing)
        {
            action(SayMerhaba)
            {
                ApplicationArea = All;
                Caption = 'Say Merhaba';
                ToolTip = 'Display a greeting in Turkish';
                Image = Comment;

                trigger OnAction()
                begin
                    Message('Merhaba! This means Hello in Turkish!');
                end;
            }
        }
    }
}
